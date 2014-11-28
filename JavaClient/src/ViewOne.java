import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import java.net.*;
import java.io.*;

import javax.swing.*;

public class ViewOne extends JFrame implements ActionListener {

	private static JTextField getStudentNumber, getFirstName, getLastName, response;
	private JFrame window;
	private static JLabel studnum, fname, lname, pword, discipline, onOff, fromServer;
	private String[] programStrings = { "EE", "CSE", "SE", "CE", };
	private String[] status = { "On Course", "Off Course", };
	private static JComboBox<String> program;
	private static JComboBox<String> onOffCourse;
	private static JPasswordField pw;
	private static JButton submit;

	public ViewOne() {

		program = new JComboBox<String>(programStrings);
		onOffCourse = new JComboBox<String>(status);
		submit = new JButton("Sign Up");
		submit.addActionListener(this);
		pw = new JPasswordField("", 9);
		pw.setEchoChar('*');

		SpringLayout layout = new SpringLayout();
		window = new JFrame("Student View 1");
		window.setLayout(layout);

		getStudentNumber = new JTextField("", 9);
		getFirstName = new JTextField("", 9);
		getLastName = new JTextField("", 9);
		response = new JTextField("",9);
		
		fromServer = new JLabel("Message received from server: ");
		onOff = new JLabel("On/Off Course: ");
		discipline = new JLabel("Select your program: ");
		studnum = new JLabel("Enter Student Number: ");
		fname = new JLabel("Enter First Name: ");
		lname = new JLabel("Enter Last Name: ");
		pword = new JLabel("Enter Password: ");

		window.add(getStudentNumber);
		window.add(studnum);
		window.add(getFirstName);
		window.add(fname);
		window.add(lname);
		window.add(getLastName);
		window.add(response);
		window.add(pword);
		window.add(pw);
		window.add(discipline);
		window.add(program);
		window.add(onOffCourse);
		window.add(onOff);
		window.add(submit);
		window.add(fromServer);

	/*
	 * SpringLayout format of all components 
	 * 
	 */
		layout.putConstraint(SpringLayout.WEST, getStudentNumber, 135,
				SpringLayout.WEST, window);
		layout.putConstraint(SpringLayout.NORTH, fname, 30, SpringLayout.NORTH,
				window);
		layout.putConstraint(SpringLayout.NORTH, getFirstName, 30,
				SpringLayout.NORTH, window);
		layout.putConstraint(SpringLayout.WEST, getFirstName, 135,
				SpringLayout.WEST, window);

		layout.putConstraint(SpringLayout.NORTH, lname, 60, SpringLayout.NORTH,
				window);
		layout.putConstraint(SpringLayout.NORTH, getLastName, 60,
				SpringLayout.NORTH, window);
		layout.putConstraint(SpringLayout.WEST, getLastName, 135,
				SpringLayout.WEST, window);

		layout.putConstraint(SpringLayout.NORTH, pword, 90, SpringLayout.NORTH,
				window);
		layout.putConstraint(SpringLayout.NORTH, pw, 90, SpringLayout.NORTH,
				window);
		layout.putConstraint(SpringLayout.WEST, pw, 135, SpringLayout.WEST,
				window);

		layout.putConstraint(SpringLayout.NORTH, discipline, 123,
				SpringLayout.NORTH, window);
		layout.putConstraint(SpringLayout.NORTH, program, 120,
				SpringLayout.NORTH, window);
		layout.putConstraint(SpringLayout.WEST, program, 135,
				SpringLayout.WEST, window);

		layout.putConstraint(SpringLayout.NORTH, onOff, 160,
				SpringLayout.NORTH, window);
		layout.putConstraint(SpringLayout.NORTH, onOffCourse, 155,
				SpringLayout.NORTH, window);
		layout.putConstraint(SpringLayout.WEST, onOffCourse, 135,
				SpringLayout.WEST, window);

		layout.putConstraint(SpringLayout.NORTH, submit, 200,
				SpringLayout.NORTH, window);

		layout.putConstraint(SpringLayout.NORTH, response, 230, SpringLayout.NORTH,
				window);
		layout.putConstraint(SpringLayout.WEST, response, 183, SpringLayout.WEST,
				window);

		layout.putConstraint(SpringLayout.NORTH, fromServer, 230, SpringLayout.NORTH,
				window);
		
		
		window.pack();
		window.setSize(350, 350);
		window.setVisible(true);
	}

	/*
	 * 
	 * Function to retrieve any text written inside text fields
	 * and return them as a string to send to server
	 */
	public static String getInfo() {
		String sn, fn, ln, chosen, chosen1, password;
		char[] pass;
		sn = getStudentNumber.getText();
		fn = getFirstName.getText();
		ln = getLastName.getText();
		pass = pw.getPassword();
		password = new String(pass);
		chosen = (String) onOffCourse.getSelectedItem();
		chosen1 = (String) program.getSelectedItem();
			
		return (sn + "-" + fn + "-" + "-" + ln + "-" + password + "-" + chosen1
				+ "-" + chosen + "\n");
	}

	public static void main(String[] args) {
		ViewOne test = new ViewOne();

	}

	/*
	 * Function to control the action of the "Submit" button.
	 * When pressed the client will retrieve the string of information entered
	 * and send to the server. It will update the gui with the response received.
	 * 
	 */
	@Override
	public void actionPerformed(ActionEvent ae) {
		if (ae.getSource() == submit) {
			String sendInfo = getInfo();

			try {
				URL urlpost = new URL(
						"http://localhost/JavaClient/serverTest.php?operation=send&user="
								+ getStudentNumber.getText());
				URLConnection connection = urlpost.openConnection();
				connection.setDoOutput(true);

				OutputStreamWriter out = new OutputStreamWriter(
						connection.getOutputStream());

				out.write("message=" + sendInfo);
				out.flush();
				
				
				BufferedReader in = new BufferedReader(new InputStreamReader(
						connection.getInputStream()));
				String responseFromServer = "";
				String text;
				while ((text = in.readLine()) != null) {
					responseFromServer += text;
				}
				response.setText(responseFromServer);
				out.close();
				in.close();

			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

	}

}